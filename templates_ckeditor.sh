#!/bin/bash

bower install ckeditor#4.x

mkdir -p libraries/

cp -R libraries/ckeditor/plugins/templates/* libraries

rm -rf libraries/ckeditor

echo "Processo concluído. O plugin de templates foi configurado."