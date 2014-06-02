import sys, os;

## Create and fill Artist table

fileScript = open('SQLArtDB.txt', 'w')

tableArtist = 'Artist'
tablePainting = 'Painting'

# delete Tables
deleteStr = 'DROP TABLE %s;\n' % (tablePainting)
fileScript.write(deleteStr)
deleteStr = 'DROP TABLE %s;\n' % (tableArtist)
fileScript.write(deleteStr)


columnNames = ['Id', 'Name', 'Description']

createStr = 'CREATE TABLE %s (\n%s int not null auto_increment primary key, \n%s varchar(300) not null, \n%s varchar(300));\n\n' % (
    tableArtist, columnNames[0], columnNames[1], columnNames[2])
fileScript.write(createStr)

dirName = r'/var/www/Art/WikiArt/'
relativeDirName = r'Art/WikiArt/'

artistIdMap = {}
counter = 1

for fileName in os.listdir(dirName):

    painterName = fileName
    artistIdMap[painterName] = counter
    counter += 1

    insertStr = 'INSERT INTO %s(%s) VALUES(\'%s\');\n' % (
        tableArtist, columnNames[1], painterName)
    fileScript.write(insertStr)

    
## Create and fill Painting table


columnNames = ['Id', 'IdPainter', 'Title', 'Address']

createStr = 'CREATE TABLE %s (\n%s int not null auto_increment primary key, \n%s int not null, \n%s varchar(300), \n%s varchar(300) not null, foreign key (%s) references Artist(Id));\n\n' % (
    tablePainting, columnNames[0], columnNames[1], columnNames[2],
    columnNames[3], columnNames[1])
fileScript.write(createStr)

for artistDir in os.listdir(dirName):

    counter = 1;
    for painting in os.listdir(dirName + artistDir):

        if painting.find('\'') >= 0:
            continue

        paintingAddress = relativeDirName + artistDir + r'/' + painting
    
        insertStr = 'INSERT INTO %s(%s, %s, %s) VALUES(%d, \'%s\', \'%s\');\n' % (
            tablePainting, columnNames[1], columnNames[2], columnNames[3],
            artistIdMap[artistDir], painting, paintingAddress)
        fileScript.write(insertStr)

        counter += 1
        if counter > 30:
            break


fileScript.close()
