#/****
#* Arma el menú superior del template. Se debe crear en la categoría uno las páginas que se quieren mostrar
#* Este menú se organiza para que cada item reaccione distinto cuando se pone el mouse encima.
#* Esto último CON EL contador del hmenu
#*
#*****/


lib.shortcuts = HMENU
lib.shortcuts.special = directory
lib.shortcuts.special {
		value = 58 #Id de la página que engloba los elementos del menú superior.
	}
lib.shortcuts.1 = TMENU
lib.shortcuts.1.alternativeSortingField=crdate desc
lib.shortcuts.1 {
  wrap = <div class="navbar-default"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button></div><nav class="collapse navbar-collapse"><ul class="nav navbar-nav">|</ul></div></nav></div>
  expAll = 0
  NO.allWrap.insertData = 1
  NO.allWrap = <li class="menu_superior_{register:count_HMENU_MENUOBJ}">|</li>
}

lib.1l1anguage1 = HMENU
lib.1l1anguage1 {
  special = language
  special.value = 0,6
  special.normalWhenNoLanguage = 0
  1 = TMENU
  1 {
    // Normal link to language which exists
    wrap = <u1>|</u1>
	NO = 1
#	NO.allWrap = |
#	NO.doNotLinkIt = 1
    NO.stdWrap.setCurrent = Español || English
    NO.stdWrap.current = 1
 
    // Current language selected
    ACT < .NO
    ACT.linkWrap = <li> | </li>
 
    // Language which is NOT available
#    USERDEF1 < .NO
#    USERDEF1.linkWrap = <span style="background-color : yellow"> | </span>
#    USERDEF1.doNotLinkIt = 1
  }
}