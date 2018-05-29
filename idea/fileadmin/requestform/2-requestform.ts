plugin.Tx_Formhandler.settings.mailer.class = Mailer_TYPO3Mailer
plugin.Tx_Formhandler.settings {   
  debug = 0
  templateFile = fileadmin/requestform/2-requestform.html  
  formValuesPrefix = formhandler    
  finishers {     
    1 {       
      class = Tx_Formhandler_Finisher_Mail     
    }     
    2 {       
      class = Tx_Formhandler_Finisher_SubmittedOK       
      config.returns = 1     
    }   
  } 
}
