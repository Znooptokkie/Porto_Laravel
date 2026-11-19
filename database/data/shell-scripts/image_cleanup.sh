# title: Delete Image Types
# description: Verwijder alle PNG- JPG- en JPEG-bestanden.
# title-en: Delete Image Types
# description-en: Delete all PNG, JPG and JPEG files.
#!/bin/bash

set -euo pipefail

find . -type f \( \
    -iname "*.png" -o \
    -iname "*.jpg" -o \
    -iname "*.jpeg" \
\) -delete

echo "Alle PNG-, JPG- en JPEG-bestanden zijn verwijderd."
