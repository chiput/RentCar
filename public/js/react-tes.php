<script type="text/babel">

    var Button=React.createClass({
        refreshData:function(){
            this.props.getData("a");
        },
        render:function(){
            return(
            <button onClick={this.refreshData}>Refresh</button>
            );
        }
    });
    var Search=React.createClass({
        handleChange:function(){
            //console.log(this.refs.search.value);
            this.props.searchData(this.refs.search.value);
        },
        render:function(){
            return (
            <input type="text" ref="search" onChange={this.handleChange} />
            )
        }
    });
    var Table=React.createClass({
        render: function() {
            var accounts=this.props.tableData.map(function(account) {
            return (
              <tr>
                <td>{account.code}</td>
                <td>{account.name}</td>
                <td>{account.type}</td>
                <td>{account.headerName}</td>
                <td className="text-nowrap"><a href="#" data-toggle="tooltip" data-original-title="Edit"> <i className="fa fa-pencil text-inverse m-r-10"></i> </a> <a href="#" data-toggle="tooltip" data-original-title="Close"> <i className="fa fa-close text-danger"></i> </a> </td>
              </tr>
              );
            });
            return (
            <table className="table table-striped">
                <thead>
                    <tr>
                        <th>No. Account</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Header</th>
                    </tr>
                </thead>
                <tbody>
                    {accounts}
                </tbody>
            </table>
            );
      }
    });
    var Main = React.createClass({
        getInitialState:function(){
            return {
                accounts:[],
                displayed:[]
            }
        },
        getData:function(data){
            console.log(data);
        },
        searchData:function(keyword){
            
            var search=this.state.accounts.filter(function (acc) {
              return acc.name.toLowerCase().indexOf(keyword.toLowerCase())>-1 
            });
            this.setState({displayed:search});
            
        },
        componentDidMount:function(){
            var component = this;
            //console.log($);
            $.get("http://localhost/project/hos/public/accounting/getall", function(data) {
                var arr=JSON.parse(data);
                //var arr = $.map(data, function (value) { return value; });
                component.setState({accounts:arr,displayed:arr});
            });
        },
        render: function() {
            return (
            <div>
                <Search searchData={this.searchData}/>
                <Table tableData={this.state.displayed}/>
                <Button getData={this.getData}/>
            </div>
            );
      }
    });
    ReactDOM.render(
        <Main/>,
        document.getElementById('root')
    );
</script>