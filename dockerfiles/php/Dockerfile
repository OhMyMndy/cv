FROM lsiobase/ubuntu:focal



RUN apt-get update -qq \
    && apt-get install -y -qq php-cli php-curl php-ctype php-dom composer curl \
    && rm -rf /var/lib/apt/lists/*



RUN curl -SsL https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.focal_amd64.deb > /tmp/wk.deb \
    && dpkg -i /tmp/wk.deb \
    ; apt-get install -f -q -yy
