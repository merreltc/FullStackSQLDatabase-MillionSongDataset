#!/usr/bin/ruby

# web-backend
# queries database
# communicates with web front-end

require 'mysql'

begin
	con = Mysql.new 'localhost', 'superuser', 'super_PASS123', 'testing'


	con.query("CREATE TABLE IF NOT EXISTS \
		Writers(Id INT PRIMARY KEY AUTO_INCREMENT, Name VARCHAR(25), Year INT)")
	con.query("INSERT INTO Writers(Name,Year) VALUES('London',1957)")
	con.query("INSERT INTO Writers(Name,Year) VALUES('Balzac',1678)")
	con.query("INSERT INTO Writers(Name,Year) VALUES('Feuchtwanger',1456)")
	con.query("INSERT INTO Writers(Name,Year) VALUES('Zola',1867)")
	con.query("INSERT INTO Writers(Name,Year) VALUES('Capote',1456)")

	rs = con.query("SELECT * FROM Writers")
	n_rows = rs.num_rows

	rs.each do |row|
		puts row
	end

	con.query("DROP TABLE Writers")


rescue Mysql::Error => e
	puts e.errno
	puts e.Error

ensure
	con.close if con
end
