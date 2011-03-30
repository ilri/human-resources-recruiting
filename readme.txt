Dump audio from FLV videos:

for file in *.flv; do echo "Processing $file... to ${file%flv}mp3"; ffmpeg -i $file -acodec copy ../audio/${file%flv}mp3; done
