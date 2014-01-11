#!/bin/sh
current_dir=$(dirname $0)
php -S 0.0.0.0:{dev-port} -t $current_dir/../www/