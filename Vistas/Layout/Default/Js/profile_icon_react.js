class Profile_icon extends React.Component {
    render() {
        return React.createElement(
                'a',
                {href: "?mod=Usuarios&cont=index&met=editar&id="+this.props.idUsuario, className:'profile-icon'},
                React.createElement(Avatar_icon),
                React.createElement(Avatar_user,this.props)
        );
    }
}

class Avatar_user extends React.Component {
    render () {
        return React.createElement(
                'span',
                null,
                this.props.userName
            );
    }
}

class Avatar_icon extends React.Component {
    render() {
        return React.createElement(
                'img',{
                    className:"avatar-24 img-circle",
                    src:'http://www.pequehogar.com.ar/Escuela/Public/Img/Fotos/Personal/Idsin_imagen.png', //this.props.user.avatarUrl',
                    alt:'this.props.user.name'
                }
        );
    }
}

$.ajax({dataType: "json",url: "?mod=Login&cont=React&met=getSession&clave=id_usuario", success:function(usuario){
        if (usuario != null && usuario["id_usuario"] > 0){
            var usuario_avatar = React.createElement(Profile_icon, {
                idUsuario: usuario["id_usuario"],
                userName: usuario["usuario"]
            });
            ReactDOM.render(usuario_avatar, document.getElementById('profile-icon'));
        }
}} );
  
