    <!DOCTYPE HTML>
    <html>
    <head>
    <title>JSON</title>
    <script type="text/javascript">
    var person={
		"phonebook" :["book" : "book1" {
			"contact":[
				{
				"fname":"Rian Ariona",
				"phone":"+628572182XXXX",
				"address":"bandung"
				},{
				"fname":"John Doe",
				"phone":"+169572582XXXX",
				"address":"Los Angeles"
				},{
				"fname":"George",
				"phone":"+196252145XXXX",
				"address":"Kanada"
				}
			]
		}
		]		
		"phonebook" : ["book" : "book2" {
			"contact":[
				{
				"fname":"Rian Ariona",
				"phone":"+628572182XXXX",
				"address":"bandung"
				},{
				"fname":"John Doe",
				"phone":"+169572582XXXX",
				"address":"Los Angeles"
				},{
				"fname":"George",
				"phone":"+196252145XXXX",
				"address":"Kanada"
				}
			]
		}
		]
    }
     for (x=0;x<person.length;x++) {
	 document.writeln(person.phonebook[x].book +"<br>");
    for(i=0;i<person.phonebook[x].book.contact.length;i++){
    document.writeln(person.phonebook[x].book.contact[i].fname +"<br>");
    //document.writeln(person.phonebook.contact[i].phone +"<br>");
    //document.writeln(person.phonebook.contact[i].address +"<br><br>");
    }
	}
    </script>
    </head>
    <body>
    </body>
    </html>