Dump audio from FLV videos:

for file in *.flv; do echo "Processing $file... to ${file%flv}mp3"; ffmpeg -i $file -acodec copy ../audio/${file%flv}mp3; done

Dump preview images from FLV videos:

for name in katjiuongua_h kathy_c tom_r yu_m stuart_w silvia_s ; do ffmpeg -y -itsoffset -4 -i ${name}.flv -vcodec mjpeg -vframes 1 -an -f rawvideo -s 130x150 ../images/people/${name}.jpg; done
