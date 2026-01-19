<?php
// upload.php (JSON API for the popup UI)
// Copyright@zee

header('Content-Type: application/json; charset=utf-8');

function respond(bool $ok, array $data = [], int $http = 200): void {
  http_response_code($http);
  echo json_encode(array_merge(['ok' => $ok], $data), JSON_UNESCAPED_SLASHES);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(false, ['error' => 'Invalid request method. Use POST.'], 405);
}

if (!isset($_FILES['image'])) {
  respond(false, ['error' => 'No file uploaded.'], 400);
}

$f = $_FILES['image'];

if (!empty($f['error'])) {
  respond(false, ['error' => 'Upload error code: ' . (int)$f['error']], 400);
}

if (!is_uploaded_file($f['tmp_name'])) {
  respond(false, ['error' => 'Invalid upload (tmp file missing).'], 400);
}

$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
$outputDir = __DIR__ . DIRECTORY_SEPARATOR . 'outputs' . DIRECTORY_SEPARATOR;

if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
  respond(false, ['error' => 'Failed to create uploads/ folder.'], 500);
}
if (!is_dir($outputDir) && !mkdir($outputDir, 0777, true)) {
  respond(false, ['error' => 'Failed to create outputs/ folder.'], 500);
}

$origName = basename((string)$f['name']);
$ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
$allowed = ['png','jpg','jpeg','webp'];

if (!in_array($ext, $allowed, true)) {
  respond(false, ['error' => 'Unsupported file type. Use PNG/JPG/JPEG/WEBP.'], 400);
}

// MIME best-effort
$mime = '';
if (function_exists('finfo_open')) {
  $fi = finfo_open(FILEINFO_MIME_TYPE);
  if ($fi) {
    $mime = finfo_file($fi, $f['tmp_name']) ?: '';
    finfo_close($fi);
  }
}
if ($mime && strpos($mime, 'image/') !== 0) {
  respond(false, ['error' => 'Uploaded file is not an image.'], 400);
}

// unique safe filenames
$base  = preg_replace('/[^a-zA-Z0-9_\-]/', '_', pathinfo($origName, PATHINFO_FILENAME));
$stamp = date('Ymd_His') . '_' . substr(bin2hex(random_bytes(4)), 0, 8);

$inputFile  = $base . '_' . $stamp . '.' . $ext;
$outputFile = $base . '_' . $stamp . '_bg_removed.png';

$inputPath  = $uploadDir . $inputFile;
$outputPath = $outputDir . $outputFile;

if (!move_uploaded_file($f['tmp_name'], $inputPath)) {
  respond(false, ['error' => 'Failed to save uploaded file into uploads/.'], 500);
}

// Python paths (Windows XAMPP)
$python = __DIR__ . "\\.venv\\Scripts\\python.exe";
$script = __DIR__ . "\\backgroundRemover.py";

if (!file_exists($python)) {
  respond(false, ['error' => 'Python venv not found: ' . $python], 500);
}
if (!file_exists($script)) {
  respond(false, ['error' => 'Python script not found: ' . $script], 500);
}

$cmd = "\"$python\" \"$script\" \"$inputPath\" \"$outputPath\"";
$out = [];
$code = 0;

exec($cmd . " 2>&1", $out, $code);

if ((int)$code !== 0 || !file_exists($outputPath)) {
  respond(false, [
    'error' => 'Background removal failed. Python returned an error.',
    'details' => $out
  ], 500);
}

$outputWeb = 'outputs/' . rawurlencode($outputFile);

respond(true, [
  'message'  => 'Background removed successfully!',
  'output'   => $outputWeb,
  'download' => $outputWeb
], 200);
