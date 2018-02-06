
<h2 class="form-title">$SiteConfig.ContactFormTitle</h2>
<form action="$Link SendForm" method="post" class="form-std">
  	<input type="text" name="name" placeholder="<%t ContactForm.NAME 'Name & Vorname *' %>" required/>
	<input type="text" name="email" placeholder="<%t ContactForm.EMAIL 'E-Mail *' %>" required/>
    <input type="text" name="telephone" placeholder="<%t ContactForm.PHONE 'Telefon' %>" />
    <textarea name="message" placeholder="<%t ContactForm.MESSAGE 'Was können wir für Sie tun?' %>"></textarea>
    <button><%t ContactForm.SEND 'Anfrage senden' %><% include DefaultIcon %></button>
    <input type="hidden" name="block" value="$ID" />
</form>
