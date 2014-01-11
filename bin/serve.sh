#!/bin/sh
current_dir=$(dirname $0)
php --server 0.0.0.0:{dev-port} --define __STAGE__=dev --docroot $current_dir/../www/ --php-ini $current_dir/../www/