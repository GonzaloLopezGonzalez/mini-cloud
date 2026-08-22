<?php
namespace App\Helpers;

class FileHelper
{

    public static function allowedMimetypes()
    {
        return ['image/jpeg', 'image/png', 'application/pdf', 'application/vnd.ms-excel','text/plain','application/x-zip-compressed','application/zip','text/csv','image/svg+xml'];
    }

    public static function allowedMimetypesByExtension()
    {
        return [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'txt' => 'text/plain',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ];
    }

   public static function reduceImageSize($rutaOrigen, $rutaDestino, $anchoMaximo, $altoMaximo)
    {
   // Obtener dimensiones originales
    list($anchoOriginal, $altoOriginal, $tipo) = getimagesize($rutaOrigen);
    
    if (!$anchoOriginal || !$altoOriginal) {
        return false;
    }

    // === CORRECCIÓN DE ORIENTACIÓN EXIF (solo JPEG) ===
    $imagenOrigen = null;
    if ($tipo == IMAGETYPE_JPEG) {
        $imagenOrigen = imagecreatefromjpeg($rutaOrigen);
        if (function_exists('exif_read_data')) {
            $exif = exif_read_data($rutaOrigen);
            if (!empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $imagenOrigen = imagerotate($imagenOrigen, 180, 0);
                        break;
                    case 6:
                        $imagenOrigen = imagerotate($imagenOrigen, -90, 0);
                        // Actualizar dimensiones después de rotar
                        $temp = $anchoOriginal;
                        $anchoOriginal = $altoOriginal;
                        $altoOriginal = $temp;
                        break;
                    case 8:
                        $imagenOrigen = imagerotate($imagenOrigen, 90, 0);
                        // Actualizar dimensiones
                        $temp = $anchoOriginal;
                        $anchoOriginal = $altoOriginal;
                        $altoOriginal = $temp;
                        break;
                }
            }
        }
    } else {
        // Para PNG y GIF, cargar normalmente
        switch ($tipo) {
            case IMAGETYPE_PNG:
                $imagenOrigen = imagecreatefrompng($rutaOrigen);
                break;
            case IMAGETYPE_GIF:
                $imagenOrigen = imagecreatefromgif($rutaOrigen);
                break;
            default:
                return false;
        }
    }

    if (!$imagenOrigen) {
        return false;
    }

    // Calcular proporciones con las dimensiones corregidas
    $ratioOriginal = $anchoOriginal / $altoOriginal;
    $ratioMaximo = $anchoMaximo / $altoMaximo;

    if ($ratioOriginal > $ratioMaximo) {
        $nuevoAncho = $anchoMaximo;
        $nuevoAlto = $anchoMaximo / $ratioOriginal;
    } else {
        $nuevoAlto = $altoMaximo;
        $nuevoAncho = $altoMaximo * $ratioOriginal;
    }
    unset($ratioOriginal, $ratioMaximo);
    // Redondear para evitar errores de GD
    $nuevoAncho = round($nuevoAncho);
    $nuevoAlto = round($nuevoAlto);

    // Crear imagen destino
    $imagenDestino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

    // Mantener transparencia en PNG y GIF
    if ($tipo == IMAGETYPE_PNG || $tipo == IMAGETYPE_GIF) {
        imagealphablending($imagenDestino, false);
        imagesavealpha($imagenDestino, true);
        
        // Fondo transparente
        $transparente = imagecolorallocatealpha($imagenDestino, 0, 0, 0, 127);
        imagefill($imagenDestino, 0, 0, $transparente);
    }

    // Redimensionar
    imagecopyresampled($imagenDestino, $imagenOrigen,0, 0, 0, 0,$nuevoAncho, $nuevoAlto,$anchoOriginal, $altoOriginal);
    unset($nuevoAncho, $nuevoAlto,$nuevoAlto,$anchoOriginal);
    // Guardar según tipo
    $guardado = false;
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $guardado = imagejpeg($imagenDestino, $rutaDestino, 90);
            break;
        case IMAGETYPE_PNG:
            $guardado = imagepng($imagenDestino, $rutaDestino, 6);
            break;
        case IMAGETYPE_GIF:
            $guardado = imagegif($imagenDestino, $rutaDestino);
            break;
    }

    unset($tipo);
    // Liberar memoria
    imagedestroy($imagenOrigen);
    imagedestroy($imagenDestino);

    return $guardado;
    }
}
