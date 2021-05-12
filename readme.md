服务器端程序的测试环境为/usr/share/nginx/html/living-easy/tp,测试环境可以调试
正式环境为/usr/share/nginx/html/tp，正式环境不能调试，为防止误删，误修改正式环境的代码，正式环境chmod 755 tp,当需要上传更改到正式环境时，使用chmod 777 tp，上传完毕后，设为可读权限
