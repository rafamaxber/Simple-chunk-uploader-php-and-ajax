function upload(target) {

  event.preventDefault();

  var file = target.target.elements.item($('#miolo')).files[0];
  var BYTES_PER_CHUNK = parseInt(2097152, 10);
  var size = file.size;
  var NUM_CHUNKS = Math.max(Math.ceil(size / BYTES_PER_CHUNK), 1);
  var start = 0;
  var end = BYTES_PER_CHUNK;
  var num = 1;

  var chunkUpload = function(blob) {
    var fd = new FormData();
    var xhr = new XMLHttpRequest();

    fd.append('upload', blob, file.name);
    fd.append('num', num);
    fd.append('num_chunks', NUM_CHUNKS);
    xhr.open('POST', 'upload.php');
    xhr.send(fd);

    console.log( fd )
  }

  while (start < size) {
    chunkUpload(file.slice(start, end));
    start = end;
    end = start + BYTES_PER_CHUNK;
    num++;
  }
}

$('form').on('submit', upload)
