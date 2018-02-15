var ModalAccount=React.createClass({
    getInitialState:function(){
        return({
            accounts:[],
            displayed:[]
        })
    },
    findAccount:function(){
        var keyWord=this.refs.search.value;
        var search=this.state.accounts.filter(function (acc) {
              return acc.name.toLowerCase().indexOf(keyWord.toLowerCase())>-1 
            });
        this.setState({displayed:search});
    },
    handleClick:function(e){
        e.preventDefault();
        this.props.getId(e.currentTarget.value);
        $('button[data-dismiss="modal"]').click();
    },
    componentDidMount:function(){

        var component=this;
            $.ajax({
                url:component.props.dataSrc,
                dataType:"JSON",
                })
                .done(function(data){
                    component.setState({accounts:data, displayed:data});
                });
    },
    render:function(){
        var component=this;
        var account=this.state.displayed.map(function(data){
            //if(data.length>0){
                var json=JSON.stringify(data);
                return(
                    <tr key={data.id}>
                        <td>{data.code}</td>
                        <td>{data.name}</td>
                        <td>
                            <button value={json} ref="btn" onClick={component.handleClick} data-toggle="tooltip" className="btn btn-default" data-original-title="Pilih"> <i className="fa fa-pencil text-inverse m-r-10"></i> Pilih</button> 
                        </td>
                    </tr>
                )    
            
        });
        var modalClass="modal fade "+this.props.modalClass;
        return(
        <div className={modalClass} tabIndex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style={{display: 'none'}}>
            <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <button type="button" className="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 className="modal-title" id="mySmallModalLabel">Daftar Account</h4>
              </div>
              <div className="modal-body">
                <input type="text" ref="search" className="form-control" placeholder="Cari Account" onChange={this.findAccount} />
                <table className="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th></th>
                        </tr>    
                    </thead>
                    <tbody>
                        {account}
                    </tbody>
                </table>
              </div>
            </div>
            </div>
        </div>
        )
    }
});




window.ModalAccount=ModalAccount;



    