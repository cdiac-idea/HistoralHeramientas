#/****
#* Se le asigna mostrar el nombre actual de la página en la parte superior.
#*
#*
#*
#*****/

lib.siteURL = COA
lib.siteURL{
  10 = TEXT
  10{
    data = page:nav_title
    wrap = |
  }
  wrap = <div class="site-url"><div class="icon">|</div></div>
}