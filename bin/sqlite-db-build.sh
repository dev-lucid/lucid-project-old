#!/bin/bash
bindir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
rm $bindir/../db/db.sqlite;
cat $bindir/../db/build.sql | sqlite3 $bindir/../db/db.sqlite; 