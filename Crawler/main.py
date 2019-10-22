# -*- coding: utf-8 -*-
from crawler import*
from pdf import*
from extract import*

content = crawler_init()
print('Fazendo Download...')
download_pdf(content)
print('Convertendo PDF\'s')
convert_pdf(content)
print('Extraindo questões')
init_extract_questions(content)
print('Extraindo Gabarito')
init_extract_answers()