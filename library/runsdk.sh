#!/usr/bin/env bash
#!/bin/bash
#echo "Setting environment variables for using the Flex SDK on OS X."
#echo ""
#echo "To invoke this script, open a Terminal window,"
#echo "type a single dot followed by a space, then drag this script"
#echo "into the Terminal so that its path appears"
#echo "right after the dot and the space."
#echo ""
#echo "Then press Enter to execute the script."
#echo ""

# environment variables
export PATH="/Applications/MAMP/htdocs/FlexSDK/bin:$PATH"

cd "/Applications/MAMP/htdocs/FlexSDK/bin/"
#java -version
#echo ""
#echo "Flex SDK version:"
#bin/mxmlc -version

#./mxmlc -help
./mxmlc /Applications/MAMP/htdocs/CodeGen/output/client/BugTracker.mxml