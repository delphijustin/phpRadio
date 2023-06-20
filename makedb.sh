#!/bin/bash
echo "Creating database..."
find . -name "*.mp3" > .htsongs
if [ $? -eq 0 ];
then
echo "Database done."
else
echo "Database failed."
fi
