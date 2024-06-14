<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @class Ads - модель объявлений
 */
class Ads extends Model
{
    use HasFactory;

    protected $table = 'ads';

    protected $fillable = ['name', 'description', 'slug', 'price'];

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        //parent::boot();

        static::creating(function (Ads $ads) {
            $ads->slug = $ads->createSlug($ads->name);
        });
    }

    /**
     * Создаёт Slug для имени
     * @param $name
     * @return Str
     */
    private function createSlug($name)
    {
        if (static::whereSlug($slug = Str::slug($name))->exists()) {
            $max = static::whereName($name)->latest('id')->value('slug');

           // dd($max);

            if (is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }

            return "{$slug}-2";
        }

        return $slug;
    }

    /**
     * Ссылки на фото
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function filenames() {
        return $this->hasMany(Photos::class, 'ads_id', "id");
    }

    /**
     * Запрос по имени
     * @param $query - объект
     * @param $slug - имя для поиска
     */
    public function scopeSlug($query, $slug) {
        $query->where('slug', $slug);
    }
}
