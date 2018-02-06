<div class="form-block">
	<form action="{$Parent.Link}SendForm" method="post" class="form-std">
	  <select name="anrede" required><option value=""><%t FormBlock.Title 'Anrede *' %></option><option value="<%t FormBlock.TITLEVALUE1 'Herr' %>"><%t FormBlock.TITLEVALUE1 'Herr' %></option><option value="<%t FormBlock.TITLEVALUE2 'Frau' %>"><%t FormBlock.TITLEVALUE2 'Frau' %></option></select>
	  <span data-icon="&#xeab5;"><input type="text" name="name" placeholder="<%t FormBlock.NAME 'Name und Vorname *' %>" required/></span>
	  <span data-icon="&#xe94c;"><input type="email" name="email" placeholder="<%t FormBlock.EMAIL 'E-Mail *' %>" required/></span>
	  <span data-icon="&#xeaf0;"><input type="text" name="telephone" placeholder="<%t FormBlock.PHONE 'Telefon' %>" /></span>
	  <span data-icon="&#xe9d6;"><textarea name="message" placeholder="<%t FormBlock.MESSAGE 'Ihre Nachricht' %>"></textarea></span>
	  <button><% if TextButton %>$TextButton<% else %><%t FormBlock.SEND 'Anfrage jetzt senden' %><% end_if %><% include DefaultIcon %></button>
	  <input type="hidden" name="block" value="$ID" />
	</form>
</div>