<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImagenController extends Controller
{
    /**
     * Metodo para generar imagenes aleatorias 
     */
    public function createUrlImagen()
    {
        $arrayUrlImage = [];
        
        for ($i=1; $i < mt_rand(3, 10); $i++) {
            
            $stringUrl  = 'https://www.colorbook.io/imagecreator.php?';
            $stringUrl .= 'hex=' .  $this->_randomColor();
            $stringUrl .= '&width='  . mt_rand(500, 900);
            $stringUrl .= '&height=' . mt_rand(200, 300);
            $stringUrl .= '&text=' . Str::random(10);

            $arrayUrlImage[] = $stringUrl;
            $stringUrl = '';
        }
        return $arrayUrlImage;
    }

    /**
     * extrae valor hexa
     */
    private function _randomColorPart() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    
    /**
     * Random colores hex
     */
    private function _randomColor() {
        return $this->_randomColorPart() . $this->_randomColorPart() . $this->_randomColorPart();
    }
}
