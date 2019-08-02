<?php

declare(strict_types=1);

namespace Prophe1\Image;

use Prophe1\Image\Utils\ImageUtils;

/**
 * Class Image
 *
 * @package Prophe1\Image
 */
final class Image
{
    /**
     * Image data
     *
     * @since 0.0.5
     *
     * @var array
     */
    private $data;

    /**
     * Allowed image attributes
     *
     * @since 0.0.5
     *
     * @var array
     */
    private $allowedAttr = [
        'alt',
        'title',
    ];

    /**
     * Image constructor.
     *
     * @since 0.0.1
     *
     * @param int $id
     * @param string|null $size
     */
    public function __construct( int $id, ?string $size )
    {
        $image_src = ImageUtils::getImageUrlByID($id, $size);

        if (! $image_src) {
            return false;
        }

        $this->data = [
            'id' => $id,
            'src' => $image_src,
            'size' => $size,
            'type' => ImageUtils::getFiletypeByLink($image_src),
            'alt' => ImageUtils::getImageAltByID($id),
            'title' => ImageUtils::getTitleByID($id),
        ];
    }

    /**
     * Checks if image is SVG
     *
     * @since 0.0.1
     *
     * @return bool
     */
    public function isSvg(): bool
    {
        $filetype = $this->getFiletype();

        if (isset($filetype['ext']) && $filetype['ext'] === 'svg') {
            return true;
        }

        return false;
    }

    /**
     * Svg content
     *
     * @since 0.0.1
     *
     * @return string
     */
    public function svg(): string
    {
        $file = get_attached_file($this->getID());
        if (!file_exists($file)) {
            return '';
        }

        return trim(file_get_contents($file));
    }

    /**
     * ID Getter
     *
     * @return int
     */
    public function getID(): int
    {
        return $this->data['id'];
    }

    /**
     * Link Getter
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->data['src'];
    }

    /**
     * Alt Getter
     *
     * @return string
     */
    public function getAlt(): string
    {
        return $this->data['alt'];
    }

    /**
     * Default size getter
     *
     * @return string|null
     */
    public function getSize(): string
    {
        return $this->data['size'];
    }

    /**
     * Title getter
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->data['title'];
    }

    /**
     * Get filetype
     *
     * @return array
     */
    public function getFiletype(): array
    {
        return $this->data['type'];
    }

    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttrs(): array
    {
        return array_intersect_key($this->data, array_flip($this->allowedAttr));
    }
}
