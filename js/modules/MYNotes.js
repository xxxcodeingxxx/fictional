import $ from 'jquery';

class MYNotes {
  constructor() {
    this.events();
  }

  events() {
    $(".delete-note").on("click", this.deleteNote);
  }

  deleteNote() {
    $.ajax({
      url: 'http://localhost/university/wp-json/wp/v2/note/168',
      type: 'DELETE',
      success: (response) => {
        console.log("Congrats");
        console.log(response);
      },
      error: (response) => {
        console.log("Sorry");
        console.log(response);
      }
    });
  }
}

export default MYNotes;
