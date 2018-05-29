#/****
#* Arma el menú superior del template. Se debe crear en la categoría uno las páginas que se quieren mostrar
#* Este menú se organiza para que cada item reaccione distinto cuando se pone el mouse encima.
#* Esto último CON EL contador del hmenu
#*
#*****/


lib.services = HMENU
lib.services.special = categories
lib.services.special.value = 1 #Id del menú superior
lib.services.1 = TMENU
lib.services.1 {
  wrap = |
  wrap  = <div id="services" style="right: -260px;" onclick="if ( this.classList.contains('active') ) {this.className=''; this.style.cssText='right: -260px';} else { this.className += 'active';this.style.cssText='right: 0px';}"><div onclick="if ( this.classList.contains('active') ) this.className = 'indicator'; else this.className += ' active';" class="indicator"></div><ul>|</ul></div>
  expAll = 0
  NO.allWrap.insertData = 1
  NO.allWrap = <li><img src="fileadmin/templates/images/icnServices.png" width="32" height="32" border="0" alt="{register:count_HMENU_MENUOBJ}">|</li>
}

#Crea el menu de arriba
#services = lib.services
