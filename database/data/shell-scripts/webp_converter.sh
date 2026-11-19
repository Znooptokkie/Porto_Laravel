# title: WEBP Converter
# description: Zet PNG- JPG- en JPEG-bestanden over naar WEBP.
# title-en: WEBP Converter
# description-en: Convert PNG, JPG and JPEG files to WEBP.
# package: imageMagick
# install: sudo pacman -S imagemagick
# install-debian: sudo apt install imagemagick

find . -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" \) -exec sh -c '
    for file do
        magick "$file" -quality 85 "${file%.*}.webp"
    done
' sh {} +

echo "Alle PNG-, JPG- en JPEG-bestanden zijn omgezet naar WEBP."
