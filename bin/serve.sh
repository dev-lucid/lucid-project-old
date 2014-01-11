#!/bin/sh
current_dir=$(dirname $0)
php --server 0.0.0.0:{dev-port} --docroot $current_dir/../www/ --php-ini $current_dir/../etc/