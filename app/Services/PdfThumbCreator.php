<?php

namespace App\Services;

class PdfThumbCreator
{
    /**
     * @param string $pdfPath
     * @return string
     */
    public function create(string $pdfPath): string
    {
        $path = public_path('storage/' . $pdfPath);
        $pdfName = str_replace('.pdf', '', $pdfPath);
        $thumbPath = 'img/' . $pdfName . '.jpg';

        $image = new \Imagick($path . '[0]');
        $image->setImageColorspace(255); // prevent image colors from inverting
        $image->setimageformat("jpeg");
        $image->thumbnailimage(200, 300);
        $image->writeimage($thumbPath);

        return $thumbPath;
    }
}