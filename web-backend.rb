#!/usr/bin/ruby

# web-backend
# queries database
# communicates with web front-end

require 'mysql'

begin
	con = Mysql.new 'localhost', 'superuser', 'super_PASS123', 'testing'


	con.query("CREATE TABLE IF NOT EXISTS \
		Writers(Id INT PRIMARY KEY AUTO_INCREMENT, Name VARCHAR(25))")
	con.query("INSERT INTO Writers(Name) VALUES('London')")
	con.query("INSERT INTO Writers(Name) VALUES('Balzac')")
	con.query("INSERT INTO Writers(Name) VALUES('Feuchtwanger')")
	con.query("INSERT INTO Writers(Name) VALUES('Zola')")
	con.query("INSERT INTO Writers(Name) VALUES('Capote')")

	rs = con.query("SELECT * FROM Writers")
	n_rows = rs.num_rows

	names = []
	
	rs.each do |row|
		names << row[1]
	end

	con.query("DROP TABLE Writers")
	
	return names.to_s


rescue Mysql::Error => e
	puts e.errno
	puts e.Error

ensure
	con.close if con
end
