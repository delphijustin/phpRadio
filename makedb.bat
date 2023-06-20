@echo off
echo Creating database
dir /b /s *.mp3 > .htsongstmp
type .htsongstmp | find /V /I "error.mp3" > .htsongs
del .htsongstmp
pause