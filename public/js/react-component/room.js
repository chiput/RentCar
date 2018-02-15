var ModalRoom=React.createClass({
    getInitialState:function(){
        return({
            rooms:[],
            displayed:[]
        })
    },
    findRoom:function(){
        var keyWord=this.refs.search.value;
        var search=this.state.accounts.filter(function (acc) {
              return acc.number.toLowerCase().indexOf(keyWord.toLowerCase())>-1 ||acc.type_name.toLowerCase().indexOf(keyWord.toLowerCase())>-1
              
            });
        this.setState({displayed:search});
    },
    handleClick:function(e){
        e.preventDefault();
        this.props.getId(e.currentTarget.value);
        $('button[data-dismiss="modal"]').click();
    },
    componentDidMount:function(){

        this.setState({rooms:this.props.rooms, displayed:this.props.rooms});

    },
    componentWillReceiveProps: function(nextProps) {
        this.setState({
            rooms:nextProps.rooms, displayed:nextProps.rooms
        },function(){
            this.forceUpdate();
        });
    },
    render:function(){
        var component=this;
        var rooms=[];
        var rooms=this.state.displayed.map(function(data){
            if(typeof(data)!="undefined"){
                var json=JSON.stringify(data);
                var rates=data.rates.map(function(rate){
                    return (
                    <tr key={data.id+rate.date}>
                        <td>{rate.date}</td>
                        <td>{rate.room_price}</td>
                        <td>{rate.room_only_price}</td>
                        <td>{rate.breakfast_price}</td>
                    </tr>
                    )
                });
                return(
                    <tr key={data.id}>
                        <td>{data.number}</td>
                        <td>{data.type_name}</td>
                        <td>
                            <table className="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Tarif</th>
                                        <th>Kamar</th>
                                        <th>Breakfast</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {rates}
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <button value={json} ref="btn" onClick={component.handleClick} data-toggle="tooltip" className="btn btn-default" data-original-title="Pilih"> <i className="fa fa-pencil text-inverse m-r-10"></i> Pilih</button> 
                        </td>
                    </tr>
                )
            }    
            
        });
        var modalClass="modal fade "+this.props.modalClass;
        return(
        <div className={modalClass} tabIndex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style={{display: 'none'}} >
            <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <button type="button" className="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 className="modal-title" id="mySmallModalLabel">Daftar Kamar</h4>
              </div>
              <div className="modal-body">
                <input type="text" ref="search" className="form-control" placeholder="Cari Account" onChange={this.findRoom} />
                <table className="table toggle-circle">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Tipe</th>
                            <th data-hide="all">Harga</th>
                            <th></th>
                        </tr>    
                    </thead>
                    <tbody>
                        {rooms}
                    </tbody>
                </table>
              </div>
            </div>
            </div>
        </div>
        )
    }
});

window.ModalRoom=ModalRoom;



    