#!/bin/bash

pushd `dirname $0` > /dev/null
SCRIPTPATH=`pwd`
popd > /dev/null

ln -fsnv ../../../../../../vendor/twbs/bootstrap/js "$SCRIPTPATH/src/CsCloud/FrontendBundle/Resources/assets/js/bootstrap"
ln -fsnv ../../../../../../vendor/twbs/bootstrap/less "$SCRIPTPATH/src/CsCloud/FrontendBundle/Resources/assets/less/bootstrap"
