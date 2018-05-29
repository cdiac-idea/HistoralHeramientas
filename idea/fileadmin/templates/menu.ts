lib.navigation = HMENU
lib.navigation.special = directory
lib.navigation.special {
		value = 57 #Id de la página que engloba los elementos del menú superior.
	}
lib.navigation {
	# options for first level
	1 = TMENU
	1 {
	# use expAll to expand all submenus
		collapse = 0
	    expAll = 1
		wrap = <div class="navbar-">|</div>
		NO {
			allWrap = <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">|<span class="caret"></span></div>
			wrapItemAndSub = <div class="btn-group btn-group">|</div> 
			#onmouseenter="this.click()">|</div>
			doNotLinkIt = 1
			}
#	    ACT < .NO
#	 if current page has sub-pages
		CURIFSUB = 1
		CURIFSUB {
			allWrap = <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">|<span class="caret"></span></div>
			#doNotLinkIt = 1
		}
	 }
#	 settings for second level
	  2 = TMENU
	  2.wrap = <ul class="dropdown-menu">|</ul>
	  2 {
		NO {
		  wrapItemAndSub = <li>|</li>
		}
	 }
}
