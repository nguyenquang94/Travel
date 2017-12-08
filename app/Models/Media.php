<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Intervention\Image\ImageManagerStatic as Image;

use Auth;

class Media extends Model
{
    use Uuid32ModelTrait;

    static function saveFile($file, $is_base64 = false)
    {
        $media = new Media;
        $media->mime_type = $file->getMimeType();
        $media->original_extension = $file->getClientOriginalExtension();
        $media->original_name = $file->getClientOriginalName();

        $media->size = $file->getSize();
        $media->save();
        if ($is_base64)
        {
            $data = base64_decode(file_get_contents($file));
            Storage::put('media/'.$media->id, $data);
        }
        else
        {
            Storage::putFileAs('media', $file, $media->id);
        }
        $media->update_image_info();
        return $media;
    }

    public function update_image_info()
    {
        $img = Image::make($this->path());
        if ($img)
        {
            $this->width = $img->width();
            $this->height = $img->height();
            $this->save();
        }
    }

    static function file($id, $width = false, $height = false, $style = false)
    {
        if ($width == false && $height == false && $style == false)
        {
            $media = Media::findOrFail($id);
            return response()->file(storage_path('app/media/'.$media->id));
        }
        else
        {
            if ($width && $height && $style)
            {
                $media = Media::findOrFail($id);
                $copy = $media->caches()->whereWidth($width)->whereHeight($height)->whereScaleType($style)->first();
                if ($copy)
                {
                    return response()->file(storage_path('app/media/'.$copy->id));
                }
                else
                {
                    $img = Image::make($media->path());
                    $needed_ratio = floatval($width) / floatval($height);
                    $current_ratio = floatval($img->width()) / floatval($img->height());

                    $cutted_width;
                    $cutted_height;
                    if ($stype = "scale_to_fill")
                    {
                        if ($needed_ratio > $current_ratio)
                        {
                            $cutted_width = $img->width();
                            $cutted_height = intval($cutted_width / $needed_ratio);
                        }
                        else
                        {
                            $cutted_height = $img->height();
                            $cutted_width = intval($cutted_height * $needed_ratio);
                        }
                    }
                    else if ($stype = "scale_to_fit")
                    {
                        if ($needed_ratio < $current_ratio)
                        {
                            $cutted_width = $img->width();
                            $cutted_height = intval($cutted_width / $needed_ratio);
                        }
                        else
                        {
                            $cutted_height = $img->height();
                            $cutted_width = intval($cutted_height * $needed_ratio);
                        }
                    }
                    $img->crop($cutted_width, $cutted_height);
                    $img->resize($width, $height);

                    $new_media = new Media;
                    $new_media->mime_type = $media->mime_type;
                    $new_media->original_extension = $media->original_extension;
                    $new_media->original_name = $media->original_name;

                    $new_media->width = $width;
                    $new_media->height = $height;
                    $new_media->scale_type = $style;

                    $new_media->original_id = $media->id;

                    $new_media->size = $img->filesize();
                    $new_media->save();

                    $img->save(storage_path('app/media/'.$new_media->id));

                    return response()->file(storage_path('app/media/'.$new_media->id));
                }
            }
        }

    }

    public function link($width = false, $height = false, $style = false)
    {
        if ($width && $height && $style)
        {
            return url("lbmedia/$this->id?width=$width&height=$height&style=$style");
        }
        return url("lbmedia/$this->id");
    }

    public function path()
    {
        return storage_path('app/media/'.$this->id);
    }

    public function original()
    {
        return $this->belongsTo("App\Models\Media", "original_id");
    }

    public function caches()
    {
        return $this->hasMany("App\Models\Media", "original_id");
    }

    static public function boot()
    {
        Media::bootUuid32ModelTrait();
        Media::saving(function ($media) {
            if (Auth::user())
            {
                if ($media->id)
                {
                    $media->updated_by = Auth::user()->id;
                }
                else
                {
                    $media->created_by = Auth::user()->id;
                }
            }
        });
    }
}
