# Using these keys below, you can do your tests on localhost, these keys are provided in the above link for testing purposes by google:
Site key: 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
Secret key: 6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe

# Utils
cd /var/www/html/sevenports
ssh -i id_rsa2.pub mpjunior@mpjunior.com.br -p 1140
iluminer01+-*/
cd ~/public_html/sevenports/

cd /home/mpjunior/public_html/sevenports


# Taferaz de programacao:

  ## Post com categoria "sem-categoria" nao sairem no tab "Recentes"
    ### wp-content/themes/zox-news/widgets/widget-tabber.php:69:84
    ### wp-content/themes/zox-news/featured.php:127:142
        
        Subir essa linea:
            $category = get_the_category(); 
        para poder comparar e filtrar:
            if ($category[0]->slug != "sem-categoria") { mostrar post }

  ## Limitar a 5 Post os assinantes
