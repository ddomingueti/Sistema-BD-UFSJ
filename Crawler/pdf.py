# -*- coding: utf-8 -*-
import requests
from pdf2jpg import pdf2jpg
import os

def download_pdf(content_dict):

	try:
		os.mkdir('Pdfs/')
	except:
		pass
	
	for links_pdf in content_dict.keys():

		#Se a prova existir não fazer o download novamente
		try:
			with open('Pdfs/Prova ' + str(links_pdf) + '.pdf', 'rb') as file_check:
				file_check.close()
				continue
		except:
			pass

		try:
		    with open('Pdfs/' + 'Prova ' + str(links_pdf) + '.pdf', "wb") as file:
		        response = requests.get(str(content_dict[links_pdf][0]))
		        file.write(response.content)
		        print('Fazendo download da prova ' + str(links_pdf))
		except:
			print('Erro ao fazer fazer download da prova ' + str(links_pdf))
			continue

		file.close()

		try:
		    with open('Pdfs/' + 'Gabarito ' + str(links_pdf) + '.pdf', "wb") as file:
		        response = requests.get(str(content_dict[links_pdf][1]))
		        file.write(response.content)
		        print('Fazendo download do gabarito ' + str(links_pdf))
		except:
			print('Erro ao Fazer download do gabarito ' + str(links_pdf))
			continue

		file.close()

def convert_pdf(content_dict):

	try:
		os.mkdir('Images')
	except:
		pass

	for key in content_dict.keys():

		found = False
		#Verfica se a prova existe
		try:
			with open('Pdfs/Prova ' + str(key) +'.pdf', 'rb') as file_check:
				found = True
				file_check.close()
		except:
			print('Erro ao converter ' + str(key))
			continue

		if found == True:
			try:	
				pdf_name = 'Pdfs/Prova ' + key + '.pdf'
				pdf2jpg.convert_pdf2jpg(pdf_name, 'Images/', pages='ALL')
				print('Convertendo Prova ' + str(key))
			except:
				print('Erro ao converter Prova ' + str(key))
				continue