FROM svikramjeet/php7.3-docker

COPY . /var/www/html

ARG PORT
ENV PORT=${PORT}

## Disabled following when running locally (keep it enabled for GCP Cloud Run)
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
