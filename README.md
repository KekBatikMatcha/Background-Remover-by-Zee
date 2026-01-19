# Background Remover

A Python-based background removal application that automatically removes image backgrounds and outputs transparent PNG images.  
This project uses a pre-trained deep learning model via the `rembg` library and was developed as an academic and personal learning project.

---

## 📌 Project Overview

Background Remover is an image processing tool designed to remove backgrounds from images using AI-based foreground segmentation.  
It supports common image formats such as JPG and PNG and produces transparent PNG outputs.

The project demonstrates:
- Python scripting
- Image processing using AI-assisted libraries
- Command-line application development
- Optional web integration using PHP

---

## 🛠️ Technologies Used
- Python 3
- rembg
- Pillow (PIL)
- HTML
- PHP (for web version)
- Apache (XAMPP)

---
## Project Structure

background-remover/
├── backgroundRemover.py
├── index.html
├── upload.php
├── uploads/
├── outputs/
├── requirements.txt
└── README.md


---

## ✅ Step-by-Step Guide (How to Use This Project)

## Step 1 — Get the Project
**Option A: Download ZIP**
1. Click **Code** → **Download ZIP**
2. Extract the ZIP file
3. Open the folder in your computer

**Option B: Clone with Git**
```
git clone https://github.com/YOUR_USERNAME/background-remover.git
cd background-remover
```
--------

## Step 2 — Install Python 

Make sure Python 3.9 or above is installed.

Check installation:
```
python --version
````
or
```
python3 --version
````
-------

## Step 3 — Create Virtual Environment (Recommended)

Windows (PowerShell):
```
python -m venv .venv
.\.venv\Scripts\Activate
```

Mac / Linux:
```
python3 -m venv .venv
source .venv/bin/activate
````
--------

## Step 4 — Install Dependencies
```
pip install rembg Pillow
```
---------

## Step 5 — Run Background Remover

Place your image inside /upload folder first then run: 

```
python backgroundRemover.py 
```
-------------
## Step 6 — View Output

Open the outputs/ folder

The output image will be saved as:

```
output.png
```

The background will be transparent

--------

🌐 Option 2: Run Using Web Version (PHP + XAMPP)

## Step 5 — Move Project into XAMPP

Copy the entire project folder into:

C:\xampp\htdocs\background-remover

-------------

## Step 6 — Start Apache Server

Open XAMPP Control Panel

Click Start on Apache

-----------------

## Step 7 — Open Web Application

Open your browser and go to:

http://localhost/background-remover/index.html

--------------------

## Step 8 — Upload Image

Click Choose File

Select a JPG or PNG image

Submit the form

The system will:

Save the image into uploads/

Execute backgroundRemover.py

Save the result into outputs/

Download or view the processed PNG image

------------------

## 📝 Notes

First execution may take longer because the AI model loads for the first time

PNG output is used to preserve transparency

Best results are achieved with clear subjects and good lighting

------------------

## 🎯 Project Purpose

This project was developed for academic learning and personal experimentation to explore Python scripting, image processing, and AI-assisted tools.
