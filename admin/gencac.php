<?php
//  ------------------------------------------------------------------------ //
//                        QUEST - MODULE FOR XOOPS 2                         //
//                  Copyright (c) 2005-2006 Instant Zero                     //
//                     <http://www.instant-zero.com/>                        //
// ------------------------------------------------------------------------- //
//  This program is NOT free software; you can NOT redistribute it and/or    //
//  modify without my assent.   										     //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed WITHOUT ANY WARRANTY; without even the       //
//  implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. //
//  ------------------------------------------------------------------------ //

/*
 * Création automatique des images des CAC
 */
include_once '../../../include/cp_header.php';
xoops_cp_header();

/**
 * @param $color
 * @return array
 */
function color_form($color)
{
    $ret = array();
    $ret = explode(',', $color);
    array_map('trim', $ret);

    return $ret;
}

/**
 * @param      $filename
 * @param      $text
 * @param      $angle
 * @param      $font
 * @param      $fontsize
 * @param      $image_width
 * @param      $image_height
 * @param      $backgroundp
 * @param      $foregroundp
 * @param null $border_color
 */
function CreatePicture($filename, $text, $angle, $font, $fontsize, $image_width, $image_height, $backgroundp, $foregroundp, $border_color = null)
{
    // Calcul des dimensions du texte
    $size   = imagettfbbox($fontsize, $angle, $font, $text);
    $width  = $size[2] - $size[0];
    $height = $size[1] - $size[7];

    // Création de l'image
    $image = imagecreatetruecolor($image_width, $image_height); // Création de l'image
    // Création des couleurs
    $background  = imagecolorallocate($image, $backgroundp[0], $backgroundp[1], $backgroundp[2]);    // Couleur de fond image non sélectionnée - Blanc
    $foreground  = imagecolorallocate($image, $foregroundp[0], $foregroundp[1], $foregroundp[2]);    // Couleur du texte, image non sélectionnée - Vert
    $bordercolor = imagecolorallocate($image, $border_color[0], $border_color[1], $border_color[2]);
    // Remplissage avec la couleur de fond
    imagefill($image, 1, 1, $background);
    // Calcul des dimensions du texte
    $x = $y = 0;
    $x = (($image_width / 2) - ($width / 2)) - 1;
    $y = $image_height - $height;
    imagettftext($image, $fontsize, $angle, $x, $y, $foreground, $font, $text);
    // Tracé de la bordure
    imageline($image, 0, 0, $image_width, 0, $bordercolor);                                // Première ligne, horizontale du haut
    imageline($image, 0, $image_height - 1, $image_width, $image_height - 1, $bordercolor);    // Deuxième ligne, horizontale du haut
    imageline($image, 0, 0, 0, $image_height - 1, $bordercolor);                                // Troisième ligne, verticale gauche
    imageline($image, $image_width - 1, 0, $image_width - 1, $image_height - 1, $bordercolor);    // Quatrième ligne, verticale droite
    // Génération de l'image
    imagepng($image, $filename . '.png');
}

if (is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid())) {
    if (isset($_POST['go'])) {
        $font         = $_POST['fontname'];                            // Police à utiliser
        $image_width  = (int)$_POST['imagewidth'];        // Largeur de l'image
        $image_height = (int)$_POST['imageheight'];        // Hauteur de l'image
        $angle        = (int)$_POST['fontangle'];                // Angle du texte
        $fontsize     = (int)$_POST['fontsize'];                // Taille de la police

        $lbordern_color = color_form($_POST['lbordern']);        // Couleur de la bordure de gauche pour les images non sélectionnées
        $lborders_color = color_form($_POST['lborders']);        // Couleur de la bordure de gauche pour les images sélectionnées
        $rbordern_color = color_form($_POST['rbordern']);        // Couleur de la bordure de droite pour les images non sélectionnées
        $rborders_color = color_form($_POST['rborders']);        // Couleur de la bordure de droite pour les images sélectionnées

        $lbackgroundn = color_form($_POST['lbackgroundn']);        // Colonne de gauche, image non sélectionnée, couleur de fond
        $lforegroundn = color_form($_POST['lforegroundn']);        // Colonne de gauche, image non sélectionnée, couleur du texte
        $lbackgrounds = color_form($_POST['lbackgrounds']);        // Colonne de gauche, image sélectionnée, couleur de fond
        $lforegrounds = color_form($_POST['lforegrounds']);        // Colonne de gauche, image sélectionnée, couleur du texte

        $rbackgroundn = color_form($_POST['rbackgroundn']);        // Colonne de droite, image non sélectionnée, couleur de fond
        $rforegroundn = color_form($_POST['rforegroundn']);        // Colonne de droite, image non sélectionnée, couleur du texte
        $rbackgrounds = color_form($_POST['rbackgrounds']);        // Colonne de droite, image sélectionnée, couleur de fond
        $rforegrounds = color_form($_POST['rforegrounds']);        // Colonne de droite, image sélectionnée, couleur du texte

        $cac_handler = xoops_getModuleHandler('cac', 'quest');
        $tbl_cac     = $cac_handler->getObjects();
        $images_path = XOOPS_ROOT_PATH . '/modules/quest/images/cac/';
        foreach ($tbl_cac as $one_cac) {
            $name1 = $images_path . 'l' . $one_cac->getVar('IdCAC') . 'n';
            $name2 = $images_path . 'l' . $one_cac->getVar('IdCAC') . 's';
            $name3 = $images_path . 'r' . $one_cac->getVar('IdCAC') . 'n';
            $name4 = $images_path . 'r' . $one_cac->getVar('IdCAC') . 's';

            CreatePicture($name1, $one_cac->getVar('LibelleCourtCac'), $angle, $font, $fontsize, $image_width, $image_height, $lbackgroundn, $lforegroundn, $lbordern_color);
            CreatePicture($name2, $one_cac->getVar('LibelleCourtCac'), $angle, $font, $fontsize, $image_width, $image_height, $lbackgrounds, $lforegrounds, $lborders_color);
            CreatePicture($name3, $one_cac->getVar('LibelleCourtCac'), $angle, $font, $fontsize, $image_width, $image_height, $rbackgroundn, $rforegroundn, $rbordern_color);
            CreatePicture($name4, $one_cac->getVar('LibelleCourtCac'), $angle, $font, $fontsize, $image_width, $image_height, $rbackgrounds, $rforegrounds, $rborders_color);
            echo '<br />' . $name1;
            echo '<br />' . $name2;
            echo '<br />' . $name3;
            echo '<br />' . $name4;
        }
        echo '<br />The End !';
    } else {
        echo '<h2>Paramétrage des cases à cocher</h2>';
        echo "<form method='post' action='" . basename(__FILE__) . "'>";
        echo "<table border='0'>";
        echo '<tr>';
        echo '<td>Colonne de gauche, image non sélectionnée, couleur de fond</td>';
        echo "<td><input type='text' name='lbackgroundn' value='255,255,255' /></td>";
        echo '</tr><tr>';
        echo '<td>Colonne de gauche, image non sélectionnée, couleur du texte</td>';
        echo "<td><input type='text' name='lforegroundn' value='0,0,0' /></td>";
        echo '</tr><tr>';
        echo '<td>Colonne de gauche, image sélectionnée, couleur de fond</td>';
        echo "<td><input type='text' name='lbackgrounds' value='88,236,0' /></td>";
        echo '</tr><tr>';
        echo '<td>Colonne de gauche, image sélectionnée, couleur du texte</td>';
        echo "<td><input type='text' name='lforegrounds' value='0,0,0' /></td>";
        echo '</tr><tr>';
        echo '<td>Colonne de droite, image non sélectionnée, couleur de fond</td>';
        echo "<td><input type='text' name='rbackgroundn' value='88,236,0' /></td>";
        echo '</tr><tr>';
        echo '<td>Colonne de droite, image non sélectionnée, couleur du texte</td>';
        echo "<td><input type='text' name='rforegroundn' value='255,255,255' /></td>";
        echo '</tr><tr>';
        echo '<td>Colonne de droite, image sélectionnée, couleur de fond</td>';
        echo "<td><input type='text' name='rbackgrounds' value='88,236,0' /></td>";
        echo '</tr><tr>';
        echo '<td>Colonne de droite, image sélectionnée, couleur du texte</td>';
        echo "<td><input type='text' name='rforegrounds' value='255,255,255' /></td>";
        echo '</tr><tr>';
        echo '<td>Couleur de la bordure pour les images de gauche  non sélectionnées</td>';
        echo "<td><input type='text' name='lbordern' value='0,0,0' /></td>";
        echo '</tr><tr>';
        echo '<td>Couleur de la bordure pour les images de gauche sélectionnées</td>';
        echo "<td><input type='text' name='lborders' value='0,0,0' /></td>";
        echo '</tr><tr>';
        echo '<td>Couleur de la bordure pour les images de droite non sélectionnées</td>';
        echo "<td><input type='text' name='rbordern' value='0,0,0' /></td>";
        echo '</tr><tr>';
        echo '<td>Couleur de la bordure pour les images de droite sélectionnées</td>';
        echo "<td><input type='text' name='rborders' value='0,0,0' /></td>";
        echo '</tr><tr>';
        echo '<td>Police Truetype à utiliser</td>';
        echo "<td><input type='text' name='fontname' value='ARIAL.TTF' /></td>";
        echo '</tr><tr>';
        echo "<td>Largeur de l'image</td>";
        echo "<td><input type='text' name='imagewidth' value='24' /></td>";
        echo '</tr><tr>';
        echo "<td>Hauteur de l'image</td>";
        echo "<td><input type='text' name='imageheight' value='24' /></td>";
        echo '</tr><tr>';
        echo '<td>Angle du texte</td>';
        echo "<td><input type='text' name='fontangle' value='0' /></td>";
        echo '</tr><tr>';
        echo '<td>Taille de la police (en pixels)</td>';
        echo "<td><input type='text' name='fontsize' value='8' /></td>";
        echo '</tr><tr>';
        echo "<td colspan='2' align='center'><input type='reset' name='raz' value='Reset' /> <input type='submit' name='go' value='Submit' /></td>";
        echo '</tr></table><i>Note, les couleurs sont à reseigner sous la forme 255,128,128</i>';
    }
} else {
    redirect_header(XOOPS_URL, 3, _NOPERM);
}
xoops_cp_footer();
