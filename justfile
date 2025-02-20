act:
    act --bind --reuse --container-options "--privileged"

build:
    mkdir -p output
    xelatex -synctex=1 -interaction=nonstopmode \
        -no-shell-escape -output-directory=output cv.tex