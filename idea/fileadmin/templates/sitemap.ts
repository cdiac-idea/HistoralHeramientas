lib.sitemap = HMENU
lib.sitemap.special = directory
lib.sitemap.special {
		value = 58 #Id de la página que engloba los elementos del menú superior.
	}
lib.sitemap {
	# options for first level
	1 = TMENU
	1 {
	# use expAll to expand all submenus
		collapse = 0
	    expAll = 1
		wrap = <div class="sitemap"><table><tr>|</tr></table></div>
		NO {
			allWrap = <td><div class="element">|</div></td>
#			wrapItemAndSub = <td class="child">|</td>
			doNotLinkIt = 1
		}
	 if current page has sub-pages
		CURIFSUB = 1
		CURIFSUB {
			allWrap = <td><div class="sitemap_child">|</div></td>
			doNotLinkIt = 1
		}
	 }
	 #settings for second level
	  2 = TMENU
	  2.wrap = <td><div id="child_elements"><ul class="child_element">|</ul></div></td>
	  2 {
		NO {
		  wrapItemAndSub = <li>|</li>
		}
		CUR < .NO
		CUR = 1
		CUR {
		  doNotLinkIt = 1
		}
	 }
}
