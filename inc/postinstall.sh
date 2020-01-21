#!/bin/bash

if [ ! -d css ]; then
  mkdir css;
fi

cp node_modules/@fortawesome/fontawesome-pro/css/all.css css/all.css
if [ $? -eq 0 ]; then
  echo "Successfully copied stylesheet";
else
  echo "ERROR: Couldn't copy stylesheet";
fi

cat inc/sow-icon-fontawesomepro-css.inc >> css/all.css
if [ $? -eq 0 ]; then
  echo "Successfully modified stylesheet";
else
  echo "ERROR: Couldn't modify stylesheet";
fi

if [ ! -d webfonts ]; then
  mkdir webfonts;
fi

cp -r node_modules/@fortawesome/fontawesome-pro/webfonts/* webfonts
if [ $? -eq 0 ]; then
  echo "Successfully copied webfonts";
else
  echo "ERROR: Couldn't copy webfonts";
fi

node parser;
