import lxml.html;
import urllib2, os;

def GetPainting(folderPath, painterName, paintingUrl):

    paintingData = lxml.html.fromstring(urllib2.urlopen(paintingUrl).read())

    for img in paintingData.xpath('//img[@itemprop="image"]'):
        imgUrl = img.get('src')
        imgName = img.get('title')
        print imgName

    try:
        imgPath = folderPath + '/' + imgName.split('-')[0].split('/')[0].rstrip() + '.img'
        open(imgPath, 'wb').write(urllib2.urlopen(imgUrl).read())
    except:
        print 'Bad name: ' + imgName
        pass
    

def ParsePainter(painterName, mainUrl, painterUrl):

    if os.path.exists('WikiArt/' + painterName):
        return

    folderPath = 'WikiArt/' + painterName
    os.makedirs(folderPath)

    print painterUrl
    painterData = lxml.html.fromstring(urllib2.urlopen(painterUrl).read())

    for ptr in painterData.xpath('//li/div/div/a[count(img)=1]'):
        GetPainting(folderPath, painterName, mainUrl + ptr.get('href'))
    

mainUrl = 'http://www.wikiart.org'
mainData = lxml.html.fromstring(urllib2.urlopen(mainUrl).read())

for ptr in mainData.xpath('//div[@class=\'jcarousel-skin-tango h65px\']/ul/li/div/p/a'):
    ParsePainter(ptr.get('title'), mainUrl, mainUrl + ptr.get('href'))

