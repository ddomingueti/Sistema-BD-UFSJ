import os
from PIL import Image 	# Importando o módulo Pillow para abrir a IMG no script
import pytesseract 		# Módulo para a utilização da tecnologia OCR
import pdftotext

# Verifica se é questão discursiva
def contains_discursive(IMG):
	
	text = pytesseract.image_to_string(Image.open(IMG))
	text = text.upper()
	
	word_search = ['DISCURSIVA', 'QUESTIONARIO','RASCUNHO']
	for word in word_search:
		matches = text.find(word)
		if matches != -1:
			return 1

	return 0


def get_num_questions(IMG):

	text = pytesseract.image_to_string(Image.open(IMG))
	text = text.upper()
	num_questions = 0
	match_questions = 0
	list = []
	try:
		while match_questions != -1:

			match_questions = text.find('QUESTAO')

			if match_questions != -1:
				num_questions+=1
				aux = text[match_questions:match_questions+10]
				aux = aux.split(' ')
				aux = aux[1]
				if aux.isnumeric() == 1:
					list.append(str(aux))
				else:
					return [], 0

				text = text.replace('QUESTAO', 'OK', 1)
	except:
		return [], 0
		print ("get_num_questions:", list)
	match_questions = text.find('AREA LIVRE')
	if match_questions != -1:
		return list, 'AL'
	return list, 0

def simple_or_double(IMG):
    
    im = Image.open(r""+IMG)
    
    width, height = im.size
    
    #Left, top, rigth, bottom
    imR = im.crop((0, 200, width/2, height))
    # IMG esquerda
    imR.save('imgEsquerda.jpg')
    
    imR = im.crop((width/2, 200, width, height))
    # IMG direita
    imR.save('imgDireita.jpg')
    
    img_left_num_questions, garbage = get_num_questions('imgEsquerda.jpg')
    img_rigth_num_questions, garbage = get_num_questions('imgDireita.jpg')
    
    if len(img_left_num_questions) == 0 and len(img_rigth_num_questions) == 0:
        return 'none', -1, -1
    
    elif len(img_left_num_questions) > 0 and len(img_rigth_num_questions) > 0:
        return 'dupla', img_left_num_questions, img_rigth_num_questions
    
    elif len(img_left_num_questions) > 0 and len(img_rigth_num_questions) == 0:
        return 'simples', img_left_num_questions, img_rigth_num_questions
    
    elif len(img_left_num_questions) == 0 and len(img_rigth_num_questions) > 0:
        return 'none', -1, -1
    return 'none', -1, -1

def work_in_page(IMG, diretorio):
	
	list_questions = []
	print ('Processando pagina: ', IMG)
	if contains_discursive(IMG) == 1:
		print ("Descartando pagina, contém discursiva")
		return -1

	# print "IMG não descartada ainda"

	im = Image.open(r""+IMG)

	width, height = im.size
	# print "Tamanho da pagina:",width,'x',height,'px'
	
	type_page, img_left_num_questions, img_rigth_num_questions = simple_or_double(IMG)
	
	if type_page == 'none': 
		print('Descartando pagina: nenhuma questão encontrada em', IMG)
		return -1

	print('Pagina: ', type_page, img_left_num_questions, img_rigth_num_questions)
	#Left, top, rigth, bottom
	coord_img = []

	if type_page == 'simples':
		coord_img.append((0, 200, width, height-250))

	elif type_page == 'dupla':
		coord_img.append((0, 200, width/2, height-250))
		coord_img.append((width/2, 200, width, height-250))

	elif True:
		input("ERRO AO IDENTIFICAR QUESTOES")
		return -1

	getQ = 0
	list_questions = img_left_num_questions + img_rigth_num_questions
	
	for i in range(len(coord_img)):
		
		left, top, right, bottom = coord_img[i][0], coord_img[i][1], coord_img[i][2], coord_img[i][3]

		saveTOP = saveBT = cont = 0
		if type_page == 'simples' and len(list_questions) == 1: 
			lx, AL = get_num_questions(IMG)
			if AL != 'AL':
				saveBT = bottom+50

		
		x = 300
		while x < height-200:

			imR = im.crop((left, top, right, x))
			imR.save('processando.jpg')

			# ENCONTROU QUESTÃO, SALVA POSIÇÃO SUPERIOR
			if saveTOP == 0:
				
				lx, AL = get_num_questions('processando.jpg')
				if len(lx) != 0:
					# print "Encontrei questao savetop = x = ", savetop,"x passou para",x+100
					saveTOP = x
					x = x + 100
					top = top + 100

			# SE NÃO TIVER AREA LIVRE
			elif saveBT == 0:
				
				lx, AL = get_num_questions('processando.jpg')
				if AL == 'AL': saveBT = x
				if len(lx) != 0: saveBT = x

			# SE ENCONTROU INICIO E FIM, CORTA IMG
			if saveTOP != 0 and saveBT != 0:
				
				imR = im.crop((left, saveTOP+10, right, saveBT-50))
				
				
				try:
					print ('SALVANDO: '+diretorio+'/'+str(list_questions[getQ])+'.jpg')
					imR.save(diretorio+'/'+str(list_questions[getQ])+'.jpg')
				except:
					pass
				saveTOP = saveBT = 0
				
				getQ+=1
				if type_page == 'simples': break
			    
			x+=15
			top+=15
		
		# SE NÃO ENCONTROU FINAL, CORTA ASSIM MESMO
		if saveTOP != 0 and saveBT == 0:
			imR = im.crop((left, saveTOP-5, right, bottom))
			if(getQ >= len(list_questions)):
				
				qetQ= len(list_questions) - 1
			try:
				imR.save(diretorio+'/'+str(list_questions[getQ])+'.jpg')
			except:
				pass
			saveTOP = saveBT = 0
			getQ+=1

	return  0


def	trabalhaNaProva(DIR_IMAGES, STORE_FOLDER):

	try:
		imagens =  os.listdir(DIR_IMAGES)
	except:
		return 0

	ID = 0
	numPages = len(imagens)
	print (numPages, " paginas")
	for i in range(0,numPages):
		OK = work_in_page(DIR_IMAGES+'/'+imagens[i], STORE_FOLDER)
		
def init_extract_questions(content):

		try:
			os.mkdir(r'Questoes')
		except:
			pass
		
		count = 0
		for key in content.keys():

			if str(key) in os.listdir(r'Questoes'):
				count += 1
				continue

			images = 'Images/Prova ' + key + '.pdf_dir'
			if '2009' in images or '2008' in images or '2007' in images or '2006' in images or '2005' in images or '2004' in images:
				#Se a prova for anterior de 2010 não pega as questões
				continue
			
			try:
				os.mkdir('Questoes/' + key)
			except:
				pass

			dire = 'Questoes/' + key
			print(images)

			trabalhaNaProva(images, dire)
			count += 1

		os.remove('imgDireita.jpg')
		os.remove('imgEsquerda.jpg')
		os.remove('processando.jpg')

def init_extract_answers():

	for proof in os.listdir(r'Questoes/'):

		try:
			with open('Pdfs/Gabarito '+str(proof)+'.pdf', 'rb') as file:
				print('Extraindo gabarito de ' + str(proof))
				pdf = pdftotext.PDF(file)
		except:
			print('Falha ao extrair gabarito de ' + str(proof))
			continue

		found = False
		for str_page in pdf:
			for i in range(0, len(str_page)):
				found_number = False
				if str_page[i].isdigit() and str_page[i+1].isdigit():
					number = str_page[i] + '' + str_page[i+1]

					carater = i
					#Pega a resposta da questao da questao
					while not str_page[carater].isalpha():
						carater+=1

					answer = str_page[carater]
					
					#Verfica a resposta da questão tem mais algum caracter além da própria resposta, se tiver, possivelment a questão foi anulada ou é uma questão discursiva
					if(str_page[carater+1].isalpha()):
						try:
							with open(r'Questoes/'+str(proof)+'/'+str(number)+'.jpg', 'rb'):
								os.remove(r'Questoes/'+str(proof)+'/'+str(number)+'.jpg')
						except:
							pass

					#Verifica se a questão existe
					try:
						with open(r'Questoes/'+str(proof)+'/'+str(number)+'.jpg', 'rb'):
							file_answer = open(r'Questoes/'+str(proof)+'/'+str(number)+'_answer.txt', 'w')
							file_answer.write(str(answer))
							file_answer.close()
					except:
						pass

					found_number = True
				elif found == False and str_page[i].isdigit() and not(str_page[i+1].isdigit()):
					number = str_page[i]

					carater = i
					#Pega a resposta da questao da questao
					while not str_page[carater].isalpha():
						carater+=1

					answer = str_page[carater]

					#Verfica a resposta da questão tem mais algum caracter além da própria resposta, se tiver, possivelment a questão foi anulada ou é uma questão discursiva
					if(str_page[carater+1].isalpha()):
						try:
							with open(r'Questoes/'+str(proof)+'/0'+str(number)+'.jpg', 'rb'):
								os.remove(r'Questoes/'+str(proof)+'/0'+str(number)+'.jpg')
						except:
							try:
								with open(r'Questoes/'+str(proof)+'/'+str(number)+'.jpg', 'rb'):
									os.remove(r'Questoes/'+str(proof)+'/'+str(number)+'.jpg')
							except:
								pass

					#Verifica se a questão existe
					try:
						with open(r'Questoes/'+str(proof)+'/0'+str(number)+'.jpg', 'rb'):
							file_answer = open(r'Questoes/'+str(proof)+'/0'+str(number)+'_answer.txt', 'w')
							file_answer.write(str(answer))
							file_answer.close()
					except:

						try:
							with open(r'Questoes/'+str(proof)+'/'+str(number)+'.jpg', 'rb'):
								file_answer = open(r'Questoes/'+str(proof)+'/'+str(number)+'_answer.txt', 'w')
								file_answer.write(str(answer))
								file_answer.close()
						except:
							pass

				#Verifica se foi encontrado um numero de dois digitos
				if found_number == True:
					found = True
				else:
					found = False