#/****
#* Se le asigna mostrar el nombre actual de la página en la parte superior.
#*
#*
#*
#*****/

#lib.updateDate = TEXT
#lib.updateDate.data = page:crdate
#lib.updateDate.strftime = %d. %b, %Y
#temp.crdate.date = d. M, Y
 
lib.copyYear = TEXT
lib.copyYear.data = date:U
lib.copyYear.strftime = %Y

 
lib.updateDate = TEXT
lib.updateDate {
  data = page:SYS_LASTCHANGED
  if.isTrue.data = page:SYS_LASTCHANGED
  date >
  wrap = <span class="text_b"></span>&nbsp;|
  strftime = %d %b, %Y
  data = SYS_LASTCHANGED
  if >
}



#lib.updateDate = COA
#lib.updateDate{
#  10 = TEXT
#  10{
#    data = page:SYS_LASTCHANGED
#	date = d-m-20y
#    wrap = |
#  }
#  wrap = |
#}


