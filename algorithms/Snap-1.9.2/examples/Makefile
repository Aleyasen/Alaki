#
# Makefile for non-Microsoft compilers
#

all: MakeAll

MakeAll:
	$(MAKE) -C agmgen
	$(MAKE) -C cascades
	$(MAKE) -C centrality
	$(MAKE) -C cliques
	$(MAKE) -C community
	$(MAKE) -C concomp
	$(MAKE) -C forestfire
	$(MAKE) -C graphgen
	$(MAKE) -C kcores
	$(MAKE) -C kronem
	$(MAKE) -C krongen
	$(MAKE) -C kronfit
	$(MAKE) -C magfit
	$(MAKE) -C maggen
	$(MAKE) -C mkdatasets
	$(MAKE) -C motifs
	$(MAKE) -C ncpplot
	$(MAKE) -C netevol
	$(MAKE) -C netstat
	$(MAKE) -C testgraph

clean:
	$(MAKE) clean -C agmgen
	$(MAKE) clean -C cascades
	$(MAKE) clean -C centrality
	$(MAKE) clean -C cliques
	$(MAKE) clean -C community
	$(MAKE) clean -C concomp
	$(MAKE) clean -C forestfire
	$(MAKE) clean -C graphgen
	$(MAKE) clean -C kcores
	$(MAKE) clean -C kronem
	$(MAKE) clean -C krongen
	$(MAKE) clean -C kronfit
	$(MAKE) clean -C magfit
	$(MAKE) clean -C maggen
	$(MAKE) clean -C mkdatasets
	$(MAKE) clean -C motifs
	$(MAKE) clean -C ncpplot
	$(MAKE) clean -C netevol
	$(MAKE) clean -C netstat
	$(MAKE) clean -C testgraph
	rm -rf Debug Release ipch
