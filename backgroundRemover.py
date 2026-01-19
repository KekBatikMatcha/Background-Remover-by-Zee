from rembg import remove, new_session
from PIL import Image
import io
import sys
import os

if len(sys.argv) != 3:
    print("Usage: python backgroundRemover.py <input_path> <output_path>")
    sys.exit(1)

input_path = sys.argv[1]
output_path = sys.argv[2]

# Limit numba to single thread to prevent hanging
os.environ["NUMBA_NUM_THREADS"] = "1"

session = new_session(model_name="u2net_human_seg")

with open(input_path, 'rb') as f:
    input_data = f.read()

output_data = remove(input_data, session=session)


output_image = Image.open(io.BytesIO(output_data))
output_image.save(output_path)

print("Background removed successfully!")
