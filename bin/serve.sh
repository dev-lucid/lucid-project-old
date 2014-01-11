#!/bin/sh
current_dir=$(pwd)
php -S 0.0.0.0:{dev-port} -t $current_dir/../www/