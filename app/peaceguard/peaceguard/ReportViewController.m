//
//  ReportViewController.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao, Robert Sanchez
//
//  Copyright (c) 2013 Number 123 Developer's Group
//

#import "ReportViewController.h"

@interface ReportViewController ()

@end

@implementation ReportViewController

@synthesize thePickerView, pickerViewBlocker;
@synthesize incidentSelection, severitySelection;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    
    thePickerView.hidden = YES;
    pickerViewBlocker.hidden = YES;
    
    thePickerView.showsSelectionIndicator = TRUE;
    thePickerView.delegate = self;
    
    
    //initializes text field display
    self.incidentData = @"Vandalism";
    self.severityData = @"Information";
    self.incidentLabel.text = self.incidentData;
    self.severityLabel.text = self.severityData;
    //should be initialized when pickerview pops up
    
    
    self.incidentSelection = [[NSArray alloc] initWithObjects: @"Vandalism", @"Graffiti", @"Person", @"Property", @"Other", nil];
    self.severitySelection = [[NSArray alloc] initWithObjects: @"Information", @"Minor", @"Serious",@"Critical", nil];

    
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//*** PickerView code starts***
- (NSInteger)pickerView:(UIPickerView *)pickerView numberOfRowsInComponent:(NSInteger)component{
    
    if (component == 0){
        return [incidentSelection count];
    }
    else {
        return [severitySelection count];
    }
    
}

//number of columns/components of picker
-(NSInteger)numberOfComponentsInPickerView:(UIPickerView *)pickerView{
    
    return 2;
    
}

-(NSString *)pickerView:(UIPickerView *)pickerView titleForRow:(NSInteger)row forComponent:(NSInteger)component{
    
    if (component == 0){
        return [incidentSelection objectAtIndex:row];
        
    }
    else {
        return [severitySelection objectAtIndex:row];
        
    }
}

//returns value from pickerview
-(void)pickerView:(UIPickerView *)pickerView didSelectRow:(NSInteger)row inComponent:(NSInteger)component{
    
    if (component == 0){
        self.incidentData = [incidentSelection objectAtIndex:row];
        self.incidentLabel.text = self.incidentData;
    }
    
    else{
        self.severityData = [severitySelection objectAtIndex:row];
        self.severityLabel.text = self.severityData;
    }
    
    return;
    
}


- (IBAction)incidentButtonPressed:(id)sender {
    if (thePickerView.hidden == YES){
        thePickerView.hidden = NO;
        pickerViewBlocker.hidden = NO;
    }
}

- (IBAction)severityButtonPressed:(id)sender {
    if (thePickerView.hidden == YES){
        thePickerView.hidden = NO;
        pickerViewBlocker.hidden = NO;
    }
}

- (IBAction)doneSelection:(id)sender {
    if (thePickerView.hidden == NO){
        thePickerView.hidden = YES;
        pickerViewBlocker.hidden = YES;
    }
}
//*** PickerView code ends ***


- (IBAction)submitAction:(id)sender {
    BOOL verification = [self verify:self.description.text];
    if(verification == YES){
        self.incidentOverviewDisplay.text = self.incidentLabel.text;
        self.severityOverviewDisplay.text = self.severityLabel.text;
        self.descriptionOverviewDisplay.text = self.description.text;
        
        
        
        if(_imageView.image!= nil){
            self.imageOverview = self.imageView.image;
        }
        [self performSegueWithIdentifier:@"ToOverView" sender:self];
    }else{
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Submit failed"
                                                        message:@"The description is null."
                                                       delegate:nil
                                              cancelButtonTitle:@"OK"
                                              otherButtonTitles:nil];
        [alert show];
    }
}

- (BOOL) verify:(NSString *)description {
    if([description isEqualToString:@"Description"]) {
        return NO;
    }else{
        return YES;
    }
}

- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self.view endEditing:YES];
}
- (IBAction)ImageTaker:(id)sender {
    
    UIImagePickerController *picker = [[UIImagePickerController alloc] init];
    UIImagePickerControllerSourceType sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
    if([UIImagePickerController isSourceTypeAvailable:UIImagePickerControllerSourceTypeCamera]){
        sourceType = UIImagePickerControllerSourceTypeCamera;
    }
    [picker setSourceType:sourceType];
    picker.allowsEditing = NO;
    picker.delegate  = self;
    if(sourceType != UIImagePickerControllerSourceTypeCamera){
        UIAlertView *altert = [[UIAlertView alloc] initWithTitle:@"No Camera" message:@"Camera is not available" delegate:self cancelButtonTitle:@"ok" otherButtonTitles:nil];
        [altert show];
    }
    [self presentViewController:picker animated:YES completion:nil];
    
}
#pragma mark -
#pragma mark UIImagePickerControllerDelegate

- (void) imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info{
    
    [self dismissViewControllerAnimated:YES completion:nil];
    UIImage *image = info[UIImagePickerControllerOriginalImage];
    _imageView.image = image;

}
- (IBAction)reviewReportToOverview:(id)sender {
}
@end
