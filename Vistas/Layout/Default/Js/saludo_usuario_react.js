class Saludo extends React.Component {
    render() {
        return React.createElement(
                'p',
                null,
                'Hola ' + this.props.nombreUsuario
                );
    }
}
var app = React.createElement('div', null,
React.createElement(Saludo, {nombreUsuario: 'usuario'})
        );

ReactDOM.render(app, document.getElementById('saludo-usuario'));
