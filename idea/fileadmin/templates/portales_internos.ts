#/**
#*Crea el script del template. En el typo3 hay que referenciar este archivo en el setup del template.
#*
#*Primero se incluyen los css para el estilo.
#*Luego se setean las rutas del template. Va por defecto a Default
#*Por último, se le asigna como layout el Home.html que hace referencia al template Default.
#*En este template se debe incluir el bootstrap y las otras ts
#**/

# Create a Fluid Template: http://typo3buddy.com/the-basics/the-main-typoscript-template/
config.no_cache = 1


# Localization:
config.linkVars = L , type
config.sys_language_uid = 0
config.language = es
config.locale_all = es_CO
config.uniqueLinkVars=1
config {
  concatenateJs = 1
  concatenateCss = 1

  compressJs = 1
  compressCss = 1
}
tx_realurl_enable = 1

[globalVar = GP:L =6]
config.sys_language_uid = 6
config.language = en
config.locale_all = en_EN
[global]


page = PAGE
page.typeNum = 0
page.includeCSS {
 file1 = fileadmin/templates/css/all.css
 file1.title = Default CSS
 file1.media = screen
 file2 = fileadmin/templates/css/homeinterno.css
 file2.title = Default CSS
 file2.media = screen

}
page.shortcutIcon = fileadmin/templates/images/favicon.ico

page.includeJS {

	file = http://code.jquery.com/jquery-1.11.1.js
	file1 = fileadmin/templates/plugins/jquery.bxslider/jquery.bxslider.js

	#PLUGIN multicontent
	file2 = typo3conf/ext/jfmulticontent/res/anythingslider/jquery.anythingslider-1.9.0.js
	file2_1 = typo3conf/ext/jfmulticontent/res/anythingslider/jquery.anythingslider-1.9.0.fx.js
	file2_2 = typo3conf/ext/jfmulticontent/res/anythingslider/jquery.anythingslider-1.9.0.video.js

	file3 = typo3conf/ext/jfmulticontent/res/booklet/jquery.booklet-1.4.2.js
	file4 = typo3conf/ext/jfmulticontent/res/easyaccordion/jquery.easyAccordion-0.2.js
	file5 = typo3conf/ext/jfmulticontent/res/slidedeck/jquery.slidedeck-1.4.3.js
	
	
	file6 = typo3conf/ext/jfmulticontent/res/jquery/js/jquery-ui-1.9.2.custom.min.js
	file7 = typo3conf/ext/jfmulticontent/res/jquery/js/jquery.mousewheel-3.1.3.min.js
	file8 = typo3conf/ext/jfmulticontent/res/jquery/js/jquery.easing-1.3.js
	file9 = typo3conf/ext/jfmulticontent/res/jquery/js/jquery.cookie.js
	
	file11 = http://code.jquery.com/ui/1.11.1/jquery-ui.js
	
}


page.10 = FLUIDTEMPLATE

page.10.file.stdWrap.cObject = CASE
page.10.file.stdWrap.cObject {
    key.data = levelfield:-1, backend_layout_next_level, slide
    key.override.field = backend_layout
    
    default = TEXT
    default.value = fileadmin/templates/home_interno.html

}

page.10 {
# Set the Template Pathes
  partialRootPath = fileadmin/templates/partials/
  layoutRootPath = fileadmin/templates/layouts/
  
    variables {
        campanha < styles.content.get
        campanha.select.where = colPos = 1

        services < styles.content.get
        services.select.where = colPos = 2
		
		info1 < styles.content.get
        info1.select.where = colPos = 3

		info2 < styles.content.get
        info2.select.where = colPos = 4

		banners < styles.content.get
        banners.select.where = colPos = 5

        languages < styles.content.get
        languages.select.where = colPos = 6

        shortcuts < styles.content.get
        shortcuts.select.where = colPos = 7

        navigation < styles.content.get
        navigation.select.where = colPos = 8

        search < styles.content.get
        search.select.where = colPos = 9

        articles-1 < styles.content.get
        articles-1.select.where = colPos = 10

        articles-2 < styles.content.get
        articles-2.select.where = colPos = 11

        articles-3 < styles.content.get
        articles-3.select.where = colPos = 12

        articles-4 < styles.content.get
        articles-4.select.where = colPos = 13


		}
	
}

<INCLUDE_TYPOSCRIPT: source="FILE: fileadmin/templates/shortcuts.ts">
<INCLUDE_TYPOSCRIPT: source="FILE: fileadmin/templates/siteURL.ts">
<INCLUDE_TYPOSCRIPT: source="FILE: fileadmin/templates/updateDate.ts">
<INCLUDE_TYPOSCRIPT: source="FILE: fileadmin/templates/migadepan.ts">
<INCLUDE_TYPOSCRIPT: source="FILE: fileadmin/templates/menu.ts">
<INCLUDE_TYPOSCRIPT: source="FILE: fileadmin/templates/banners.ts">