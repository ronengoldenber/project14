
PHPDIR := $(DESTDIR)/var/www/backend

build:

install:
	install -d -g www-data -o www-data $(PHPDIR)
	install -d -g www-data -o www-data $(PHPDIR)/configuration
	install -d -g www-data -o www-data $(PHPDIR)/dialplan
	install -d -g www-data -o www-data $(PHPDIR)/directory
	install -d -g www-data -o www-data $(PHPDIR)/phrases
	install -d -g www-data -o www-data $(PHPDIR)/vm
	install -d -g www-data -o www-data $(PHPDIR)/voiceapi
	install -g www-data -o www-data *.php $(PHPDIR)
	install -g www-data -o www-data configuration/*.php $(PHPDIR)/configuration
	install -g www-data -o www-data dialplan/*.php $(PHPDIR)/dialplan
	install -g www-data -o www-data directory/*.php $(PHPDIR)/directory
	install -g www-data -o www-data phrases/*.php $(PHPDIR)/phrases
	install -g www-data -o www-data vm/*.php $(PHPDIR)/vm
	install -g www-data -o www-data voiceapi/*.php $(PHPDIR)/voiceapi

