# -*- coding: utf-8 -*-

from bs4 import BeautifulSoup as BS
import requests

def crawler_init():

	req = requests.get('http://portal.inep.gov.br/educacao-superior/enade/provas-e-gabaritos') # Rquisição para a página do enade
	soup = BS(req.text, 'html.parser')
	years = soup.find_all(class_='list-download--three-columns filter-item') 	#Captura as informações de todos os anos.
	years.append(soup.find_all(class_='list-download--three-columns filter-item filter-item--active'))
	content = dict()									# Relaciona os links dos pdf de acordo com as áreas.

	if req.status_code != 200:
		print ('Falha ao baixar pagina')
		exit(1)

	for year in years:
		
		try:
			str_year = str(year.find('h2').text)
			href = year.find_all('a')
			study_areas = year.find_all('h6')
		except:
			continue

		areas_list = list() #Salva as areas de um ano específico

		for study_area in study_areas:
			areas_list.append(study_area.text)

		links_list = list() #Salva os links de um ano específico

		for link in href:
			links_list.append(link.get('href'))

		count = 0
		for key in areas_list:

			aux_list_links = list()
			str_key = str(key) + " " + str_year
			
			try:
				aux_list_links.append(links_list[count])
				aux_list_links.append(links_list[count+1])
			except:
				continue

			content.update({str(str_key):aux_list_links})
			count+=3

	return content	