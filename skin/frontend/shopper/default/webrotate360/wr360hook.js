function WR360AdhocEmbedInitialize(placeholder, viewerWidth, viewerHeight, graphicsPath, configFileURL, rootPath, licensePath)
{
	var imageBlock = jQuery(placeholder);
	if (imageBlock.length <= 0)
		return;
	
	if (viewerWidth != "")
        imageBlock.css("width", viewerWidth);

	if (viewerHeight != "")
        imageBlock.css("height", viewerHeight)

    imageBlock.css("padding", 0);
	var newHtml = "<div id='wr360PlayerId'> \
                      <script language='javascript' type='text/javascript'> \
                         _imageRotator.settings.graphicsPath   = '" + graphicsPath + "'; \
                         _imageRotator.settings.configFileURL  = '" + configFileURL + "'; \
                         _imageRotator.settings.rootPath  = '" + rootPath + "'; \
                         _imageRotator.licenseFileURL =  '" + licensePath + "'; \
                      </script> \
                   </div>";

    imageBlock.html(newHtml);
    imageBlock.css("visibility", "visible");
	_imageRotator.runImageRotator("wr360PlayerId");
}


function WR360AdhocPopupInitialize(placeholder, framePath, thumbPath, prettyTheme)
{
    var imageBlock = jQuery(placeholder);
    if (imageBlock.length <= 0)
        return;

    var newHtml = "<a href='" + framePath + "'" + "rel='prettyPhoto'><img src='" + thumbPath + "'/></a>";
    imageBlock.html(newHtml);
    imageBlock.css("visibility", "visible");

    if (prettyTheme == "default")
        jq360("a[rel^='prettyPhoto']").prettyPhoto();
    else
        jq360("a[rel^='prettyPhoto']").prettyPhoto({theme:prettyTheme});
}

jq360 = jQuery.noConflict();


