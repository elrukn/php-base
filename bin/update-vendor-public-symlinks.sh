#!/bin/bash



### Shell settings
#
set -e



### Swithch to directory of this file, and out to project root
#
MY_DIR=`dirname $0`
cd $MY_DIR
cd ../../../..



### Get all vendor/*/public and vendor/*/*/public dirs
#
VENDOR_PUBLIC_DIRS=`cd vendor && ls -d */public */*/public`
for VPD in $VENDOR_PUBLIC_DIRS; do
    VPD_PATH_NO1=`dirname $VPD`
    VPD_PATH_NO2=`dirname $VPD_PATH_NO1`

    SYMLINK_DEPTH=`echo "$VPD" | sed -e 's@[^/]@@g' | awk '{ print length }' | xargs expr 2 +`

    SYMLINK_PUBLIC_BACKPATH=`perl -E "say '../' x $SYMLINK_DEPTH"`
    SYMLINK_DIR="public/vendor/$VPD_PATH_NO2"
    SYMLINK_PATH="public/vendor/$VPD_PATH_NO1"
    SYMLINK_DEST="${SYMLINK_PUBLIC_BACKPATH}vendor/$VPD"

    # Check if symlink to this publicdir already exists?
    if [ -h $SYMLINK_PATH ]; then

        # Verify if correct destination
        CUR_DEST=`readlink $SYMLINK_PATH`
        if [ "$CUR_DEST" != "$SYMLINK_DEST" ]; then
            echo "ERROR: Symlink points to invalid destination!"
            echo "Symlink path: $SYMLINK_PATH"
            echo "Current dest: $CUR_DEST"
            echo "Desired dest: $SYMLINK_PATH"
            exit 1
        else
            echo "Already symlinked: $SYMLINK_PATH ---> $SYMLINK_DEST"
            continue;
        fi
    fi

    echo "Creating symlink $SYMLINK_PATH ---> $SYMLINK_DEST"
    mkdir -p $SYMLINK_DIR
    ln -s $SYMLINK_DEST $SYMLINK_PATH
done
